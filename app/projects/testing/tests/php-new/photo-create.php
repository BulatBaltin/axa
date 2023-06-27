<?
// Загружаем картинку и печать
// http://forum.php.su/topic.php?forum=62&topic=16

$stamp  = imagecreatefrompng(ROUTER::ModulePath().'sign.png');
$im     = imagecreatefrompng(ROUTER::ModulePath().'photo.png');
 
// Выбираем позции нашей печати на новом изображении. 10 пикселей от левого правого угла
// что делают две других функции я уверен ты знаешь из документации
$marge_right = 10;
$marge_bottom = 10;
$sx = imagesx($stamp);
$sy = imagesy($stamp);
 
// Копируем печать на исходное изображение
// Какие параметры и их значения ты поймёшь пролистав доку. =)
imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
 
// Выводим новое изображение и очищаем память
// header('Content-type: image/png');
imagepng($im, './images/photo2.png');

// die;
// imagedestroy($im);
?>