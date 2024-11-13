<?php

require_once 'src/models/News.php';
require_once 'src/util/Image.php';
require_once 'src/util/request.php';

switch (parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)) {

    case '/news/submit':

        $data = handle_request(['title', 'content']);

        $image = Image::handleImageUpload('news', true, 500, 500);

        if ($image->uploaded) {
            $id = News::newNews($data['title'], $data['content'], $image->getPath(), $_SESSION['username']);
        } else {
            $id = News::newNews($data['title'], $data['content'], null, $_SESSION['username']);
        }

        echo json_encode(['message' => 'New news submitted with id ' . $id]);

        break;


    case '/news/get/count':
        
        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;
        News::getTotalPages($limit);
        
        break;

    case '/news/get':

        $data = handle_request(['page', 'limit']);

        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;
        $offset = ($page - 1) * $limit;

        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;
        News::getTotalPages($limit);

        News::getNews($data['limit'], $offset);
        break;

    case '/news/all':
        require 'src/models/News.php';
        News::getAllNews();
        break;

    default:
        break;
        echo '404';
}
