<?php

require 'src/models/News.php';
require_once 'src/util/images.php';

switch (parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)) {

    case '/get/news':

        $data = validate_json_request(['page', 'limit']);

        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;
        $offset = ($page - 1) * $limit;
        News::getNews($data['limit'], $offset);
        break;

    case '/get/totalpages':
        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;
        News::getTotalPages($limit);
        break;

    case '/news/all':
        require 'src/models/News.php';
        News::getAllNews();
        break;

    default:
        break;
        echo '404';
}

$uploadDir = 'public/images';
$thumbDir = 'public/images/news/thumbs/';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}
if (!is_dir($thumbDir)) {
    mkdir($thumbDir, 0755, true);
}

$title = $_POST['title'];
$content = $_POST['content'];
$date = date('Y-m-d');


$imagePath = '';
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

    $fileTmpPath = $_FILES['image']['tmp_name'];
    $imageInfo = getimagesize($fileTmpPath);
    $fileType = $imageInfo['mime'];

    if (strpos($fileType, 'image/') === 0) {

        $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
        $destination = $uploadDir . $fileName;

        if (move_uploaded_file($fileTmpPath, $destination)) {
            $thumbPath = $thumbDir . $fileName;
            createThumbnail($destination, $thumbPath, 300, 200);
            $imagePath = $thumbPath;
        } else {
            echo "Fehler beim Hochladen des Bildes.";
            exit;
        }
    } else {
        echo "Bitte laden Sie eine gültige Bilddatei hoch.";
        exit;
    }
}

# Saves news in database
News::saveNews($title, $content, $imagePath, $date);

header('Location: /news');
exit();