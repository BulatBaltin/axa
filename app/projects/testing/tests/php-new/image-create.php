<?PHP

// create a 100*100 image
$img = imagecreatetruecolor(500, 500);

// allocate some colors
$red = imagecolorallocate($img, 255, 0, 0);
$green = imagecolorallocate($img,   0, 255,   0);
$blue = imagecolorallocate($img,   0, 0, 255);

// draw some lines
imageline($img, 40, 30, 40, 40, $red);
imageline($img, 50, 30, 50, 40, $green);
imageline($img, 45, 38, 45, 39, $blue);

imageline($img, 37, 45, 53, 45, $blue);
imageline($img, 37, 43, 37, 45, $green);
imageline($img, 53, 43, 53, 45, $red);

// // output image in the browser
header("Content-type: image/png");
// imagepng($img);

// // free memory
// imagedestroy($img);
?>