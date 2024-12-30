<?php

require_once 'src/config/Database.php';
require_once 'src/util/validation.php';

class News
{
    public static $max_title_length = 100;
    public static $max_content_length = 0;
    public $title;
    public $content;
    public $image;
    public $created_by;
    public $created;
    public $modified;
    public $is_published;

    private function __construct($title, $content, $image, $user)
    {
        // Validate title length
        if (strlen($title) > self::$max_title_length) {
            throw new Exception("Title exceeds maximum length of " . self::$max_title_length . " characters.");
        }

        // Validate content length
        if (strlen($content) > self::$max_content_length && self::$max_content_length != 0) {
            throw new Exception("Content exceeds maximum length of " . self::$max_content_length . " characters.");
        }

        $this->title = $title;
        $this->content = $content;
        $this->image = $image;
        $this->created_by = $user;
        $this->created = date('Y-m-d H:i:s');
        $this->modified = $this->created;
        $this->is_published = false;
    }

    public static function getDBConnection()
    {
        return Database::getInstance()->getConnection();
    }

    public static function newNews($title, $content, $image, $user)
    {
        // Creates news object
        $news = new News($title, $content, $image, $user);

        // Saves to database
        $news->saveNews();

        // Returns the news id
        return $news->getId();
    }

    public static function getAllNews()
    {

        $stmt = self::getDBConnection()->prepare("SELECT * FROM news");

        $stmt->execute();
        $result = $stmt->get_result();
        $news = [];
        while ($row = $result->fetch_assoc()) {
            $news[] = $row;
        }
        return sanitizeArray($news);
    }

    public static function getNews($limit, $offset)
    {

        isValidArray([$limit, $offset], [ValidationTypes::integer, ValidationTypes::integer]);

        $stmt = self::getDBConnection()->prepare("SELECT * FROM news ORDER BY date DESC LIMIT ? OFFSET ?");
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();

        $newsPosts = [];
        while ($row = $result->fetch_assoc()) {
            $newsPosts[] = $row;
        }
        return sanitizeArray($newsPosts);
    }

    public static function getTotalPages($limit)
    {

        isValidArray([$limit], [ValidationTypes::integer]);

        $totalResult = self::getDBConnection()->query("SELECT COUNT(*) AS total FROM news");
        $totalRow = $totalResult->fetch_assoc();
        $totalNews = $totalRow['total'];

        $totalPages = ceil($totalNews / $limit);

        return sanitizeString($totalPages);
    }

    public static function getPaginatedNews($limit, $offset)
    {

        isValidArray([$limit, $offset], [ValidationTypes::integer, ValidationTypes::integer]);
        $stmt = self::getDBConnection()->prepare("SELECT * FROM news ORDER BY created_at DESC LIMIT ? OFFSET ?");
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();

        $news = [];
        while ($row = $result->fetch_assoc()) {
            $news[] = $row;
        }

        return sanitizeArray($news);
    }


    public function saveNews()
    {
        $stmt = self::getDBConnection()->prepare("INSERT INTO news (title, content, image_path, created_by) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $this->title, $this->content, $this->image, $this->created_by);
        $stmt->execute();
    }

    public function getId()
    {
        $stmt = self::getDBConnection()->prepare("SELECT news_id FROM news WHERE title = ? AND content = ?");
        $stmt->bind_param("ss", $this->title, $this->content);
        $stmt->execute();
        $result = $stmt->get_result();
        $id = $result->fetch_assoc();
        return sanitizeString($id["news_id"]);
    }

    public static function getNewsById($id)
    {
        $stmt = self::getDBConnection()->prepare("SELECT * FROM news WHERE news_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $news = $result->fetch_assoc();
        return sanitizeArray($news);
    }

    public static function deleteNews($id)
    {
        $stmt = self::getDBConnection()->prepare("DELETE FROM news WHERE news_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    public static function updateNews($newsId, $title, $content, $imagePath = null)
    {
        isValidArray([$newsId, $title, $content, $imagePath], [ValidationTypes::integer, ValidationTypes::strict_string, ValidationTypes::strict_string, ValidationTypes::url]);
        if ($imagePath) {
            $stmt = self::getDBConnection()->prepare("UPDATE news SET title = ?, content = ?, image_path = ? WHERE news_id = ?");
            $stmt->bind_param("sssi", $title, $content, $imagePath, $newsId);
        } else {
            $stmt = self::getDBConnection()->prepare("UPDATE news SET title = ?, content = ? WHERE news_id = ?");
            $stmt->bind_param("ssi", $title, $content, $newsId);
        }
        $stmt->execute();
        $stmt->close();
    }


}
