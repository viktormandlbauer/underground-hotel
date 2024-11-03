<?php include 'src/views/includes/header.php'; ?>

<title>News Detail</title>

<?php
require 'src/config/dbaccess.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    if ($id > 0) {
        $stmt = $conn->prepare("SELECT * FROM news WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $post = $result->fetch_assoc();
        } else {
            echo "<div class='news-container'><p>Artikel nicht gefunden.</p></div>";
            include 'src/views/includes/footer.php';
            exit();
        }
    } else {
        echo "<div class='news-container'><p>Ungültige Artikel-ID.</p></div>";
        include 'src/views/includes/footer.php';
        exit();
    }
} else {
    echo "<div class='news-container'><p>Keine Artikel-ID angegeben.</p></div>";
    include 'src/views/includes/footer.php';
    exit();
}
?>

<div class="news-container">
    <div class="news-item">
        <h2><?php echo htmlspecialchars($post['title'] ?? ''); ?></h2>
        <?php if (!empty($post['image_path'])): ?>
            <img src="/<?php echo htmlspecialchars($post['image_path'] ?? ''); ?>" alt="News Bild">
        <?php endif; ?>
        <p><?php echo nl2br(htmlspecialchars($post['content'] ?? '')); ?></p>
        <div class="news-date">
            Veröffentlicht am <?php echo htmlspecialchars($post['date'] ?? ''); ?>
        </div>
    </div>
    <div class="back-to-news">
        <a href="news.php">← Zurück zur News-Übersicht</a>
    </div>
</div>

<?php include 'src/views/includes/footer.php'; ?>
