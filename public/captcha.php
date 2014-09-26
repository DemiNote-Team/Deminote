<?php
    header('Content-type: image/png');
    session_name("osmium");
    session_start();
    $letters = 'ABCDEFGKKLMNOPRSTUVWXYZ123456789';
    $caplen = 5;
    $captcha = '';
    $width = 110;
    $height = 40;
    $font = $_SERVER["DOCUMENT_ROOT"] . '/public/SegoeUI.ttf';
    $fontsize = 14;
    $im = imagecreatetruecolor($width + 9, $height);
    $bg = imagecolorallocatealpha($im, 255, 255, 255, 127);
    imagefill($im, 0, 0, $bg);
    for ($i = 0; $i < 10; $i++) {
        $x1 = mt_rand(0, $width);
        $y1 = mt_rand(0, $height);
        $x2 = mt_rand(0, $width);
        $y2 = mt_rand(0, $height);
        $curcolor = imagecolorallocate($im, rand(80, 200), rand(80, 200), rand(80, 200));
        imageline($im, $x1, $y1, $x2, $y2, $curcolor);
    }
    for ($i = 0; $i < 1000; $i++) {
        $x = mt_rand(0, $width);
        $y = mt_rand(0, $height);
        $curcolor = imagecolorallocate($im, rand(0, 100), rand(0, 100), rand(0, 100));
        imagesetpixel($im, $x, $y, $curcolor);
    }
    for ($i = 0; $i < $caplen; $i++) {
        $captcha .= $letters[rand(0, strlen($letters) - 1)];
        $x = ($width - 10) / $caplen * $i + 6;  
        $x = rand($x, $x + 4);
        $y = $height - (($height - $fontsize) / 2);
        $curcolor = imagecolorallocate($im, rand(0, 100), rand(0, 100), rand(0, 100));
        $angle = rand(-15, 15);
        imagettftext($im, $fontsize, $angle, $x, $y, $curcolor, $font, $captcha[$i]);
    }
    $_SESSION['captcha'] = $captcha;
    imagepng($im);
?>