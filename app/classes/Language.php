<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2013
 */


class Language {

  protected $currentLanguage;
  protected $languagesList;
  protected $libruary;

  protected $defaultLanguage;
  protected $defaultLibruary;

  const TEXT_PLACEHOLDER = '$';
  const CONFIG_PREFFIX = 'language.';

  public function __construct()
  {
    $config = Service::getConfig();
    $this->defaultLanguage = $config->get('default_language');
    $this->languagesList = $config->get('list', 'languages');
  }

  public function setLanguage($language)
  {
    if (!in_array($language, $this->languagesList)) {
      throw new Exception_LanguageError('Error during setting Language.');
    }
    if ($this->currentLanguage) {
      throw new Exception_LanguageError('Languge cant be setted second time');
    }
    $this->currentLanguage = $language;
    $this->libruary = Service::getConfig()->get('libruary', self::CONFIG_PREFFIX . $this->currentLanguage);
  }

  /**
   * Returns text by key name
   * @param $key
   * @return string
   */
  public function get($key)
  {
    if (empty($this->currentLanguage)) {
      $this->setLanguage($this->defaultLanguage);
    }
    if (isset($this->libruary[$key])) {
      return $this->libruary[$key];
    }
    if($this->currentLanguage != $this->defaultLanguage) {
      if (empty($this->defaultLibruary)) {
        $this->defaultLibruary = Service::getConfig()->get('libruary', self::CONFIG_PREFFIX . $this->defaultLanguage);
      }
      if (isset($this->defaultLibruary[$key])) {
        return $this->defaultLibruary[$key];
      }
    }
    return self::TEXT_PLACEHOLDER . $key . self::TEXT_PLACEHOLDER;
  }
}