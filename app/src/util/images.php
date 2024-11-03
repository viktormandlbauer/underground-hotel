<?php
function createThumbnail($src, $dest, $desiredWidth, $desiredHeight)
{
    $imageInfo = getimagesize($src);
    if ($imageInfo === false) {
        return false;
    }
    $type = $imageInfo[2];


    switch ($type) {
        case IMAGETYPE_JPEG:
            $sourceImage = imagecreatefromjpeg($src);
            break;
        case IMAGETYPE_PNG:
            $sourceImage = imagecreatefrompng($src);
            break;
        case IMAGETYPE_GIF:
            $sourceImage = imagecreatefromgif($src);
            break;
        default:
            return false;
    }


    $width = imagesx($sourceImage);
    $height = imagesy($sourceImage);

    $virtualImage = imagecreatetruecolor($desiredWidth, $desiredHeight);
    imagecopyresampled($virtualImage, $sourceImage, 0, 0, 0, 0, $desiredWidth, $desiredHeight, $width, $height);

    imagejpeg($virtualImage, $dest);
    imagedestroy($sourceImage);
    imagedestroy($virtualImage);

    return true;
}
