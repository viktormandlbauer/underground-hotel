<?php include 'src/views/includes/header.php'; ?>
<?php require 'src/controllers/NewsController.php'; ?>

<style>
    .news-container {
        max-width: 800px;
        margin: 50px auto;
        padding: 0 20px;
    }

    .news-item {
        background-color: rgba(255, 255, 255, 0.85);
        padding: 20px;
        margin-bottom: 30px;
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.6);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(2px);
        text-align: center;
    }

    .news-item h2 {
        font-size: 24px;
        margin-bottom: 15px;
    }

    .news-item p {
        font-size: 16px;
        line-height: 1.5;
    }

    .news-date {
        font-size: 14px;
        color: #aaa;
        text-align: right;
        margin-top: 10px;
    }

    .pagination {
        display: flex;
        justify-content: center;
        list-style: none;
        padding: 0;
    }

    .pagination li {
        margin: 0 5px;
    }

    .pagination a {
        text-decoration: none;
        padding: 10px 15px;
        color: #007bff;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #fff;
    }

    .pagination a.active {
        background-color: #007bff;
        color: #fff;
    }
</style>

<body>

    <div class="news-container">
        <?php foreach ($news as $item): ?>
            <div class="news-item">
                <h2><?= htmlspecialchars($item['title']) ?></h2>
                <?php if (!empty($item['image_path'])): ?>
                    <img src="/<?= htmlspecialchars($item['image_path']) ?>" alt="News Bild"
                        style="max-width: 100%; border-radius: 5px;">
                <?php endif; ?>
                <p><?= nl2br(htmlspecialchars($item['content'])) ?></p>
                <div class="news-date">Veröffentlicht am <?= htmlspecialchars($item['created_at']) ?></div>
            </div>
        <?php endforeach; ?>
    </div>

    <nav aria-label="Page navigation">
        <ul class="pagination">
            <?php if ($page > 1): ?>
                <li><a href="?page=<?= $page - 1 ?>">« Vorherige</a></li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li><a href="?page=<?= $i ?>" class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a></li>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <li><a href="?page=<?= $page + 1 ?>">Nächste »</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</body>

<?php include 'src/views/includes/footer.php'; ?>