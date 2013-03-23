<?php


class PHPGSpeechAPI {
  protected $_oCurl;
  protected $_sLang;

  const ERROR_SUCCESS = 0;
  const ERROR_LANGUAGE_NOT_DEFINED = 1;
  const ERROR_TEXT_TOO_LONG = 2;
  const ERROR_CURL_ERROR = 4;

  public function __construct(){
    $this->_oCurl = curl_init();
    $this->_sLang = null;
  }
  public function setLanguage($psLang){
    $this->_sLang = $psLang;
  }

  public function recognize($psFile){
    if(is_null($this->_sLang) || empty($this->_sLang)){
      return $this::ERROR_LANGUAGE_NOT_DEFINED;
    }
    curl_setopt($this->_oCurl, CURLOPT_URL, 'https://www.google.com/speech-api/v1/recognize?lang='.$this->_sLang);
    curl_setopt($this->_oCurl, CURLOPT_HTTPHEADER, array('Content-Type: audio/x-flac; rate=16000'));
    curl_setopt($this->_oCurl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($this->_oCurl, CURLOPT_POST, true);
    curl_setopt($this->_oCurl, CURLOPT_POSTFIELDS, array('Content_Type'=>'audio/x-flac; rate=16000','Content'=>file_get_contents($psFile)));
    curl_setopt($this->_oCurl, CURLOPT_RETURNTRANSFER, true);
    $resData = curl_exec($this->_oCurl);
    if($resData !== false){
      $resData = json_decode($resData, true);
      if(isset($resData['hypotheses'][0]['utterance'])){
        return $resData['hypotheses'][0]['utterance'];
      } else {
        return false;
      }
    } else {
      return $this::ERROR_CURL_ERROR;
    }
  }

  public function translate($psText, $psFile){
    if(strlen($psText) > 100){
      return $this::ERROR_TEXT_TOO_LONG;
    }
    if(is_null($this->_sLang) || empty($this->_sLang)){
      return $this::ERROR_LANGUAGE_NOT_DEFINED;
    }
    $hContentMP3 = file_get_contents('http://translate.google.com/translate_tts?tl='.$this->_sLang.'&q='.urlencode($psText));
    return file_put_contents($psFile, $hContentMP3);
  }
}