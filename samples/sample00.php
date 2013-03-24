<?php
  include_once '../PHPGSpeechAPI/PHPGSpeechAPI.php';

  #ffmpeg.exe -i sample00.mp3 -acodec flac -aq 100 -ar 16000 sample00.flac
  $oPHPGSpeechAPI = new PHPGSpeechAPI();
  $oPHPGSpeechAPI->setLanguage('fr');
  echo $oPHPGSpeechAPI->recognize(getcwd().DIRECTORY_SEPARATOR.'sample00.flac');
