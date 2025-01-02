<?php include 'src/views/includes/header.php'; ?>
<?php require 'src/controllers/NewsController.php'; ?>
<link rel="stylesheet" href="/public/css/dropzone.css">

<body>
    <?php include 'src/views/includes/navbar.php'; ?>

    <div class="container mt-5 content-wrapper">
        <?php foreach ($news as $item): ?>
            <div class="card mb-4">
                <div class="card-body bg-dark text-white rounded clearfix">
                    <h2 class="card-title text-center"><?= htmlspecialchars($item['title']) ?></h2>
                    <?php if (!empty($item['image_path'])): ?>
                        <img src="/<?= htmlspecialchars($item['image_path']) ?>" alt="News Bild" class="rounded mr-3 mb-2"
                            style="max-width: 250px; max-height: 500px; float: left; border-radius: 5px; margin-right: 15px; margin-bottom: 15px;">
                    <?php endif; ?>
                    <p class="card-text text-justify"><?= nl2br(htmlspecialchars($item['content'])) ?></p>
                    <div class="text-right text-muted mt-3">Veröffentlicht am <?= htmlspecialchars($item['created_at']) ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page - 1 ?>">« Vorherige</a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page + 1 ?>">Nächste »</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
    <?php include 'src/views/includes/footer.php'; ?>
</body>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital@0;1&family=Roboto:ital,wght@0,500;0,700;1,400;1,500&display=swap');

    .card {
        font-family: "Protest Revolution", sans-serif;
        font-weight: 400;
        font-style: normal;
    }

    .card-title {
        font: 700 1.5rem/1.2 "Protest Revolution", sans-serif;
    }
</style>