<?php

require_once 'src/util/Hash.php';

class Image
{
    public static int $max_upload_size = 500000000;
    public static array $allowed_types = ['jpg', 'png', 'gif'];
    public static array $allowed_categories = ['news', 'user', 'rooms'];
    public static string $image_store_path = 'public/images/';

    private string $name;
    public string $category;
    public bool $uploaded = false;

    private function setName($extension)
    {
        $this->name = Hash::unique() . '.' . $extension;
    }

    public function getPath()
    {
        return self::$image_store_path . $this->category . '/' . $this->name;
    }

    public static function handleImageUpload($category, $compress = false, $compression_height = 0, $compression_width = 0): Image
    {

        $image = new Image();

        // Check if image file is an actual image
        if (!getimagesize($_FILES["imageFile"]["tmp_name"])) {
            $image->uploaded = false;
            return $image;
        }

        $image->category = $category;

        $extension = strtolower(pathinfo($_FILES["imageFile"]["name"], PATHINFO_EXTENSION));

        do {
            $image->setName($extension);
            $target_file = $image->getPath();
        } while (file_exists($target_file));

        // Check file size
        if ($_FILES["imageFile"]["size"] > self::$max_upload_size) {
            $image->uploaded = false;
            return $image;
        }

        // Allow certain file formats
        if (!in_array($extension, self::$allowed_types)) {
            $image->uploaded = false;
            return $image;
        }

        // Check if $uploadOk is set to 0 by an error
        if (move_uploaded_file($_FILES["imageFile"]["tmp_name"], $target_file)) {
            $image->uploaded = true;
        } else {
            $image->uploaded = false;
            return $image;
        }


        if ($compress) {
            if (!$image->compressImage($compression_width, $compression_height)) {
                $image->uploaded = false;
                throw new Exception('Image compression failed');
            }
        }

        return $image;
    }

    public function compressImage($desiredWidth, $desiredHeight)
    {

        $image_path = $this->getPath();
        $imageInfo = getimagesize($image_path);
        if ($imageInfo === false) {
            return false;
        }
        $type = $imageInfo[2];


        switch ($type) {
            case IMAGETYPE_JPEG:
                $sourceImage = imagecreatefromjpeg($image_path);
                break;
            case IMAGETYPE_PNG:
                $sourceImage = imagecreatefrompng($image_path);
                break;
            case IMAGETYPE_GIF:
                $sourceImage = imagecreatefromgif($image_path);
                break;
            default:
                return false;
        }


        $width = imagesx($sourceImage);
        $height = imagesy($sourceImage);


        $virtualImage = imagecreatetruecolor($desiredWidth, $desiredHeight);
        imagecopyresampled($virtualImage, $sourceImage, 0, 0, 0, 0, $desiredWidth, $desiredHeight, $width, $height);

        $this->setName('jpg');
        imagejpeg($virtualImage, $this->getPath());
        imagedestroy($sourceImage);
        imagedestroy($virtualImage);
        unlink($image_path);

        return true;
    }
}
