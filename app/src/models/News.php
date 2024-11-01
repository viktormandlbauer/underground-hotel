<?php

require 'src/config/Database.php';

class News{

    public static function getDBConnection()
    {
        return Database::getInstance()->getConnection();
    }

    
    public static function getAllNews(){
        
        $stmt = self::getDBConnection()->prepare("SELECT * FROM news");
        $stmt->execute();
        $result = $stmt->get_result();
        $news = [];
        while ($row = $result->fetch_assoc()) {
            $news[] = $row;
        }
        return $news;
    }

    public static function getNews($limit, $offset){

        header('Content-Type: application/json');
        
        global $conn;

        $stmt = self::getDBConnection()->prepare("SELECT * FROM news ORDER BY date DESC LIMIT ? OFFSET ?");
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();

        $newsPosts = [];
        while ($row = $result->fetch_assoc()) {
            $newsPosts[] = $row;
        }

        echo json_encode(['news' => $newsPosts]);
    }

    public static function getTotalPages($limit) {
        header('Content-Type: application/json');

        global $conn;

        $totalResult = self::getDBConnection()->query("SELECT COUNT(*) AS total FROM news");
        $totalRow = $totalResult->fetch_assoc();
        $totalNews = $totalRow['total'];
        
        $totalPages = ceil($totalNews / $limit);

        echo json_encode(['totalPages' => $totalPages]);
    }

    public static function submitNews ($title, $content, $imagePath) {
        global $conn;

        $stmt = $self::getDBConnection()->prepare("INSERT INTO news (title, content, image_path) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $content, $imagePath);
        $stmt->execute();
    }
}