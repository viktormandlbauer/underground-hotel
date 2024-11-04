<?php

require_once 'src/models/News.php';
require_once 'src/util/Image.php';
require_once 'src/util/request.php';

switch ($_SERVER['REQUEST_URI']) {

    case '/news/submit':

        $data = handle_request(['title', 'content']);        
        
        $image = Image::handleImageUpload();
        
        if(!$image->uploaded){
            echo json_encode(['message' => 'Image upload failed']);
        }

        $id = News::newNews($data['title'], $data['content'], $image->name, $_SESSION['username']);   

        echo json_encode(['message' => 'New news submitted with id ' . $id]);

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