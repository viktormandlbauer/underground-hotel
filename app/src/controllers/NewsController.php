<?php

require_once 'src/models/News.php';
require_once 'src/models/User.php';
require_once 'src/util/Image.php';
require_once 'src/util/request.php';


global $request;

switch ($request) {

    case '/news':
        $limit = 20;
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

        if ($page < 1)
            $page = 1;

        $offset = ($page - 1) * $limit;
        $news = News::getPaginatedNews($limit, $offset);
        $totalPages = News::getTotalPages($limit);

        break;

    case '/news/submit':

        $data = handle_request(['title', 'content']);

        $image = Image::handleImageUpload('news', true, 720, 480);

        $user_id = User::getUseridByUsername($_SESSION['username']);

        if ($image->uploaded) {
            $id = News::newNews($_POST['title'], $_POST['content'], $image->getPath(), $user_id);
        } else {
            $id = News::newNews($_POST['title'], $_POST['content'], null, $user_id);
        }

        header('Location: /news');
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
        include 'src/views/includes/404.php';
        break;
}
