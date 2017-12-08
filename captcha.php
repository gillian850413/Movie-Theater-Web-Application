<?php

//error_reporting(E_ALL); //除錯用

if(!isset($_SESSION)){ 
    session_start(); 
}  //判斷session是否已啟動

$x=0; $y=0; $ans_right_move=''; 

$img = imagecreate(85,26);

$red = imagecolorallocate($img,255,0,0);  //文字顏色
$gray = imagecolorallocate($img,200,200,200);  //背影顏色

imagefill($img,0,0,$gray);

mt_srand((double)microtime() * 1000000);  //重置隨機值

//隨機30點
$s_dot = imagecolorallocate($img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,128));
for($i=0; $i<30; $i++){
     imagesetpixel($img,mt_rand(10,75),mt_rand(5,20),$s_dot);
}

//文字隨機浮動
$x = mt_rand(5,10);
for($i=0; $i<6; $i++){
     $ans_right_move = substr($_SESSION['capt_word'],$i,1);
     $y = mt_rand(1,8);
     imagestring($img,5,$x,$y,$ans_right_move,$red);
     $x = $x + mt_rand(8,14);
}

//輸出圖片
header('Content-type: image/png');

imagepng($img);

imagedestroy($img);

?>