<?php
  include_once '../PHPGSpeechAPI/PHPGSpeechAPI.php';
  if(file_exists('sample01.flac')){
    @unlink('sample01.flac');
  }
  if(file_exists('sample01.mp3')){
    @unlink('sample01.mp3');
  }
  if(file_exists('sample01.ogg')){
    @unlink('sample01.ogg');
  }
  if(file_exists('sample01.wav')){
    @unlink('sample01.wav');
  }

  $oPHPGSpeechAPI = new PHPGSpeechAPI();
  $oPHPGSpeechAPI->setLanguage('fr');
  $oPHPGSpeechAPI->translate('Bonjour Progi1984, je suis content de vous rencontrer', 'sample01.mp3');

  # define your FFMpeg path
  $psFFMpeg = '';
  if(file_exists($psFFMpeg)){
    exec('"'.$psFFMpeg.'" -i sample01.mp3 -acodec flac -aq 100 -ar 16000 sample01.flac');
    exec('"'.$psFFMpeg.'" -i sample01.mp3 -acodec vorbis -aq 100 sample01.ogg');
    exec('"'.$psFFMpeg.'" -i sample01.mp3 -aq 100 sample01.wav');
  }
?>
<!DOCTYPE html>
<html>
  <head></head>
  <body>
    <audio preload="auto" autobuffer controls id="audio">
      <?php if(file_exists('sample01.mp3')): ?><source src="sample01.mp3" type="audio/mpeg" /><?php endif; ?>
      <?php if(file_exists('sample01.flac')): ?><source src="sample01.flac" type="audio/flac" /><?php endif; ?>
      <?php if(file_exists('sample01.ogg')): ?><source src="sample01.ogg" type="audio/ogg" /><?php endif; ?>
      <?php if(file_exists('sample01.wav')): ?><source src="sample01.wav" type="audio/wav" /><?php endif; ?>
    </audio>
  </body>
</html>
