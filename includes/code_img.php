<?php
include 'phpqrcode.php'; 
$value = $_GET['url'];//二维码内容 
//var_dump($value);
$errorCorrectionLevel = 'L';//容错级别 
$matrixPointSize = 6;//生成图片大小 
//生成二维码图片 
Header("Content-type: image/png");
QRcode::png($value); 

