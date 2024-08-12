<?php
session_start();
$codigoCaptcha = substr(md5(time()) ,0, 2);
$_SESSION['captcha'] = $codigoCaptcha;
$im = imagecreate(100, 30);

$bg = imagecolorallocate($im, 234, 236, 239);
$textcolor = imagecolorallocate($im, 0, 0, 0);
  
imagestring($im,50,15,5, $codigoCaptcha, $textcolor);
imagepng($im);
?>