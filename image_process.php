<?php

    //MINIATURKA
    $originalPath = 'static/images/original/'.$fileName;

    if($mimeType==='image/png')
        $img = imagecreatefrompng($originalPath);
    else
        $img = imagecreatefromjpeg($originalPath);
    $x = imagesx($img);
    $y = imagesy($img);

    $xMin = 200;
    $yMin = 125;
    $imgMin = imagecreatetruecolor($xMin,$yMin);

    imagecopyresampled($imgMin, $img, 0,0,0,0 ,$xMin, $yMin, $x, $y);

    if($mimeType==='image/png')
        imagepng($imgMin, 'static/mages/miniature/'.$fileName, 100);
    else
        imagejpeg($imgMin, 'static/images/miniature/'.$fileName, 100);

    imagedestroy($img);
    imagedestroy($imgMin);


    //ZNAK WODNY
    $originalPath = 'static/images/original/'.$fileName;

    if($mimeType==='image/png')
        $img = imagecreatefrompng($originalPath);
    else
        $img = imagecreatefromjpeg($originalPath);

    $imgColor = imagecreatetruecolor(1000, 1000);
    $color = imagecolorallocate($imgColor, 255, 255, 255);


    // LEPSZY WATERMARK
    $font = 'static/gothic.ttf';
    $size = imagesx($img)/70;
    $marginX = imagesx($img)/20;
    $marginY = (imagesy($img)/20)*19;

    imagettftext($img, $size, 0, $marginX, $marginY, $color, $font, $_POST['watermark']);
    

    if($mimeType==='image/png')
        imagepng($img, 'static/images/watermark/'.$fileName, 100);
    else
        imagejpeg($img, 'static/images/watermark/'.$fileName, 100);

    imagedestroy($img);
    imagedestroy($imgColor);