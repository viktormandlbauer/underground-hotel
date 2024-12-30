<?php

require_once 'src/models/News.php';
require_once 'src/models/User.php';
require_once 'src/util/Image.php';

global $request;
global $method;

switch ([$request, $method]) {

    case ['/news', 'GET']:
        $limit = 20;
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

        if ($page < 1)
            $page = 1;

        $offset = ($page - 1) * $limit;
        $news = News::getPaginatedNews($limit, $offset);
        $totalPages = News::getTotalPages($limit);

        break;

    case ['/news/submit', 'POST']:

        $image = Image::handleImageUpload('news', true, 720, 480);

        $user_id = User::getUseridByUsername($_SESSION['username']);

        if ($image->uploaded) {
            $id = News::newNews($_POST['title'], $_POST['content'], $image->getPath(), $user_id);
        } else {
            $id = News::newNews($_POST['title'], $_POST['content'], null, $user_id);
        }

        header('Location: /news');
        break;

    case ['/news/get/count', 'GET']:

        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;
        News::getTotalPages($limit);

        break;

    case ['/news/get', 'GET']:

        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;
        $offset = ($page - 1) * $limit;

        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;
        News::getTotalPages($limit);

        News::getNews($data['limit'], $offset);
        break;

    case ['/news/all', 'GET']:
        News::getAllNews();
        break;

    case ['/admin/manage/news', 'GET']:

        if (authenticated() && authorized("admin")) {
            $news = News::getAllNews();
        } else {
            require 'src/error/401.php';
        }
        break;

    case ['/admin/news/edit', 'POST']:
        if (authenticated() && authorized("admin")) {
            if (isset($_POST['news_id'], $_POST['title'], $_POST['content'])) {
                $newsId = intval($_POST['news_id']);
                $title = trim($_POST['title']);
                $content = trim($_POST['content']);

                if (isset($_FILES['imageFile']) && $_FILES['imageFile']['error'] === UPLOAD_ERR_OK) {
                    $image = Image::handleImageUpload('news', true, 720, 480);
                    if ($image->uploaded) {
                        $imagePath = $image->getPath();
                    } else {
                        $imagePath = null;
                    }
                } else {
                    $imagePath = null;
                }

                News::updateNews($newsId, $title, $content, $imagePath);

                $_SESSION['flash_message'] = 'News-Beitrag erfolgreich aktualisiert.';
                header('Location: /admin/manage/news');
                exit;
            } else {
                $_SESSION['flash_message'] = 'Ungültige Anfrage.';
                header('Location: /admin/manage/news');
                exit;
            }
        } else {
            require 'src/error/401.php';

        }
        break;

    case ['/admin/news/delete', 'POST']:

        if (authenticated() && authorized("admin")) {
            if (isset($_POST['news_id'])) {
                $newsId = intval($_POST['news_id']);

                News::deleteNews($newsId);

                $_SESSION['flash_message'] = 'News-Beitrag erfolgreich gelöscht.';
                header('Location: /admin/manage/news');
                exit;
            } else {
                $_SESSION['flash_message'] = 'Ungültige Anfrage.';
                header('Location: /admin/manage/news');
                exit;
            }
        } else {
            require 'src/error/401.php';

        }
        break;


    default:
        include 'src/error/404.php';
        break;
}