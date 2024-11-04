<?php

require_once 'src/util/Hash.php';

class Image
{
    public static $maxSize = 500000;
    public static $allowedTypes = ['jpeg', 'png', 'gif'];
    public static $image_store_path = 'public/images/news/';
    public $path_prefix = '';
    public $name;
    public $uploaded = false;

    private function setName($extension)
    {
        // Generate a unique name for the image
        $this->name = Hash::unique() . '.' . $extension;
    }

    public function getPath()
    {
        return self::$image_store_path . $this->name;
    }

    public static function handleImageUpload(): Image
    {

        $image = new Image();

        // Check if image file is an actual image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["imageFile"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }
        }

        $extension = strtolower(pathinfo($_FILES["imageFile"]["name"], PATHINFO_EXTENSION));
        $image->setName($extension);

        $target_file = self::$image_store_path . $image->name;

        // Check if file already exists
        while (file_exists($target_file)) {
            $image->setName($extension);
            $target_file = self::$image_store_path . $image->name;
        }

        // Check file size
        if ($_FILES["imageFile"]["size"] > self::$maxSize) {
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (!in_array($extension, self::$allowedTypes)) {
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 1){
            if (move_uploaded_file($_FILES["imageFile"]["tmp_name"], $target_file)) {
                $image->uploaded = true;
            }
        }
        return $image;
    }

    public static function compressImage($src, $dest, $desiredWidth, $desiredHeight)
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
}
