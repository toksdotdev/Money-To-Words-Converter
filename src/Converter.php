<?php

/**
 * Coverts a money value to senetence
 * 
 * @category Money
 * @author   Tochukwu Nkemdilim <nkemdilimtochukwu@gmail.com>
 * @license  MIT https://github.com/TNkemdilim/Money-To-Words-Converter/licence.md
 * @link     https://github.com/TNkemdilim/Money-To-Words-Converter
 * 
 * Date: 11:22am June-17-2017
 * ALL THE GLORY BE TO CHRIST JESUS.
 */

namespace TNkemdilim\MoneyToWords;

use Exception;
use TNkemdilim\MoneyToWords\Helpers\StringProcessing;
use TNkemdilim\MoneyToWords\Helpers\NumericSystem;
use TNkemdilim\MoneyToWords\Helpers\Digit;
use TNkemdilim\MoneyToWords\Languages as Language;

use TNkemdilim\MoneyToWords\Grammar\SentenceGenerator;
use TNkemdilim\MoneyToWords\Grammar\Translator;

/**
 * USAGE:
 * $converter = new Converter("naira",  "kobo");
 * echo ($converter->convert(345));
 *
 */
class Converter
{
    /**
     * Whole number section of the monetary value to convert.
     * 
     * A list of numeric systems can be found at: 
     * https://en.wikipedia.org/wiki/List_of_numeral_systems
     * 
     * @var Numeric
     */
    protected $moneyWholePart;

    /**
     * Decimal number section of the monetary value to convert.
     * 
     * @var Numeric
     */
    protected $moneyDecimalPart;

    /**
     * Language translator.
     * 
     * @var TNkemdilim\MoneyToWords\Grammar\Translator
     */
    protected $translator;


    /**
     * Is the given monetary value a decimal?
     *
     * @var boolean
     */
    protected $isDecimal = false;

    /**
     * Currency to use for whole number part of the given monetary value.
     * 
     * @var String
     */
    protected $currencyForWhole;

    /**
     * Currency to use for decimal part of the given monetary value.
     *
     * @var String
     */
    protected $currencyForDecimal;


    /**
     * Create a new money to word converter.
     * 
     * @param String $currencyForWhole   Currency for whole number part of money
     * @param String $languageTo         Language to convert money in words to
     * @param String $currencyForDecimal Currency to use for decimal part of the given monetary value.
     */
    function __construct(
        $currencyForWhole,
        $currencyForDecimal,
        $languageTo = Language::ENGLISH
    ) {
        $this->setCurrency(trim($currencyForWhole), trim($currencyForDecimal));
        $this->translator = new Translator(trim($languageTo));
    }

    /**
     * Get the language which money values are translated into.
     * 
     * @return Language Translation language
     */
    public function getTransalationLanguage()
    {
        return $this->translator->getDestinationLanguage();
    }

    /**
     * Set a new currency for money value.
     * 
     * @param String $currencyForWhole   Currency in word fo whole money part e.g. naira, dollar, pounds, yens etc.
     * @param String $currencyForDecimal Currency in word e.g. cent (assuming dollar is passed as `$currencyForWhole`)
     * 
     * @return void
     */
    public function setCurrency($currencyForWhole, $currencyForDecimal = '')
    {
        $this->currencyForWhole = trim($currencyForWhole);
        $this->currencyForDecimal = trim($currencyForDecimal);
    }

    /**
     * Set the language of translation.
     * 
     * @param String $languageTo Language to translate into
     * 
     * @return void
     */
    public function setLanguage(Language $languageTo)
    {
        $this->translator->setLanguage(trim($languageTo));
    }

    /**
     * Set a new money value for convertion.
     * 
     * @param String $moneyValue Money value to convert
     * 
     * @return void
     */
    private function _setMoney(String $moneyValue)
    {
        $moneyValue = trim($moneyValue);
        // Translate into greek numeric system of 0 - 9.
        if (!NumericSystem::isGreek($moneyValue)) {
            $moneyValue = $this->translator->toArabic($moneyValue);
        }

        $moneyValue = number_format($moneyValue, 2, '.', '');

        $isDecimal = Digit::isDecimal($moneyValue);

        if ($isDecimal) {
            $values = explode('.', $moneyValue);

            $this->moneyDecimalPart = intval($values[1]);
            $this->moneyWholePart = intval($values[0]);
        } else {
            $this->moneyWholePart = $moneyValue;
        }

        $this->isDecimal = $isDecimal;
    }

    /**
     * Performs the conversion of the given movey value from digit to words.
     * 
     * @param String $moneyValue Money value of any language, in which should be converted to words
     * 
     * @return String Converted sentence
     */
    public function convert($moneyValue)
    {
        $this->_setMoney($moneyValue);

        if ($this->isDecimal) {
            return $this->_convertWholeAndDecimalPart();
        }

        return $this->_convertWholePart();
    }

    /**
     * Converts the money value specified into sentence, given that the money 
     * value is a whole number and not a decimal.
     *
     * @return String
     */
    private function _convertWholePart()
    {
        try {
            $sentence = SentenceGenerator::generateSentence($this->moneyWholePart);

            if ($sentence != "") {
                $sentence .= " " . $this->currencyForWhole . " only";

                if ($this->getTransalationLanguage() != Language::ENGLISH) {
                    return $this->translator->translate($sentence);
                }
            }

            return $sentence;
        } catch (\Exception $ex) {
            throw new \Exception("Invalid inputs");
        }
    }

    /**
     * Converts the money value specified into sentence, given that the money 
     * value is a decimal.
     *
     * @return String
     */
    private function _convertWholeAndDecimalPart()
    {
        $whole = SentenceGenerator::generateSentence($this->moneyWholePart);
        $decimal = SentenceGenerator::generateSentence($this->moneyDecimalPart);

        if (!$this->_translationIsEnglish()) {
            $whole = $this->translator->translate($whole);
            $decimal = $this->translator->translate($decimal);
        }

        if ($whole != "") {
            $whole .= " " . $this->currencyForWhole;
        }
        if ($decimal != "") {
            $decimal .= " " . $this->currencyForDecimal;
        }
        if ($whole != "" && $decimal != "") {
            $whole .= ", ";
        }

        $sentence = trim($whole . $decimal);

        if ($sentence == "") return $sentence;
        if ($this->_translationIsEnglish()) return "{$sentence} only";

        $only = $this->translator->translate('only');
        return $this->translator->translate("{$sentence} {$only}");
    }

    /**
     * Is english the current language for translation.
     *
     * @return boolean
     */
    private function _translationIsEnglish(): bool
    {
        return $this->getTransalationLanguage() == Language::ENGLISH;
    }
}
