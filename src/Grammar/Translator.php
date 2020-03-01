<?php

namespace TNkemdilim\MoneyToWords\Grammar;

use Exception;
use Google\Cloud\Translate\TranslateClient;
use Google\Cloud\Core\Exception\ServiceException;
use TNkemdilim\MoneyToWords\Languages as Language;

class Translator
{
    /**
     * Google translator.
     * 
     * @var Stichoza\GoogleTranslate\GoogleTranslate
     */
    protected $translator;

    /**
     * The language of the money value (numeral) inserted.
     * 
     * @var TNkemdilim\MoneyToWords\Languages
     */
    protected $languageTo;

    /**
     * Create a new translation client.
     *
     * @param Language $languageTo Destination Language to use for translation
     */
    function __construct(String $languageTo)
    {
        $this->languageTo = $languageTo;
        $this->translator = new TranslateClient();
    }

    /**
     * Set the language of translation.
     * 
     * @param Language $languageTo Language to translate into
     * 
     * @return void
     */
    public function setLanguage(Language $languageTo)
    {
        $this->$languageTo = $languageTo;
    }

    /**
     * Get the language used for translation.
     *
     * @return TNkemdilim\MoneyToWords\Languages
     */
    public function getDestinationLanguage()
    {
        return $this->languageTo;
    }

    /**
     * Translates the money input into previously configured language.
     * 
     * @param String $string Text to translate
     * 
     * @return void
     */
    public function translate(String $string)
    {
        try {
            return $this->translator->translate(
                $string,
                ['target' => $this->languageTo]
            );
        } catch (ServiceException $ex) {
            throw new Exception($ex->getMessage());
        } catch (Exception $ex) {
            throw new Exception("Error translating. Please insert a valid input");
        }
    }

    /**
     * Translates the money input to any language.
     * 
     * @param String $string   Text to translate
     * @param String $language Language to convert into
     * 
     * @return void
     */
    public function to(String $string, String $language)
    {
        $translation = null;
        $tempLanguageTo = $this->languageTo;

        try {
            $this->languageTo = $language;
            $translation = $this->translate($string);
        } finally {
            $this->languageTo = $tempLanguageTo;
        }

        return $translation;
    }

    /**
     * Translates the money value to english.
     * 
     * @param String $string Text to translate
     * 
     * @return String Translated text in english
     */
    public function toEnglish($string)
    {
        return $this->to($string, Language::ENGLISH);
    }

    /**
     * Translates the money value to arabic.
     * 
     * @param String $string Text to translate
     * 
     * @return String Translated text in greek
     */
    public function toArabic($string)
    {
        return $this->to($string, Language::ARABIC);
    }
}
