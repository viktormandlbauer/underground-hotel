<?php include 'src/views/includes/header.php'; ?>
<link rel="stylesheet" href="/public/css/modal.css">
<body>
    <?php include 'src/views/includes/navbar.php'; ?>
    <div class="container mt-5 content-wrapper">
    <div class="row bg-dark text-white py-4 rounded">
        <h1 id="Pages" class="mb-4 text-center display-3">Newsverwaltung</h1>

        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="alert alert-info alert-dismissible fade show" id="flashMessage">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Schließen"></button>
                <?= $_SESSION['flash_message'];
                unset($_SESSION['flash_message']); ?>
            </div>
            <script src='/public/js/flashMessage.js'></script>
        <?php endif; ?>

        <div class="table-responsive">
            <table id="sortedTable" class="table table-dark table-bordered table-bordered align-middle table-hover tablesorter">
                <thead>
                    <tr>
                        <th scope="col" data-sort="number">ID</th>
                        <th scope="col" data-sort="text">Titel</th>
                        <th scope="col" data-sort="text">Bild</th>
                        <th scope="col" data-sort="text">Inhalt</th>
                        <th scope="col" data-sort="date">Erstellt am</th>
                        <th scope="col" data-sort="text">Erstellt von</th>
                    </tr>
                </thead>
                <tbody id="newsTableBody">
                    <?php foreach ($news as $article): ?>
                        <tr class="news-row" style="cursor-pointer" data-news-id="<?= $article['news_id']; ?>"
                            data-title="<?= htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8'); ?>"
                            data-image-path="<?= htmlspecialchars($article['image_path'], ENT_QUOTES, 'UTF-8'); ?>"
                            data-content="<?= htmlspecialchars($article['content'], ENT_QUOTES, 'UTF-8'); ?>"
                            data-created-at="<?= $article['created_at']; ?>" 
                            data-created-by="<?= $article['created_by']; ?>">
                            <td><?= htmlspecialchars($article['news_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?= htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="text-center">
                                <?php if (!empty($article['image_path'])): ?>
                                    <img src="/<?= htmlspecialchars($article['image_path'], ENT_QUOTES, 'UTF-8'); ?>" alt="News Bild" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                <?php else: ?>
                                    <span class="text-muted">Kein Bild</span>
                                <?php endif; ?>
                            </td>
                            <td><?= nl2br(htmlspecialchars($article['content'], ENT_QUOTES, 'UTF-8')); ?></td>
                            <td><?= date('d.m.Y H:i', strtotime($article['created_at'])); ?></td>
                            <td><?= htmlspecialchars(User::getUsernameByID($article['created_by']), ENT_QUOTES, 'UTF-8'); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="7" class="text-center">
                             <button type="button" id="addRow" class="add-row" data-bs-toggle="modal" data-bs-target="#newsUploadModal">
                                <i class="fas fa-plus plus-icon"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
    </div>

    <!-- upload news modal -->
    <div class="modal fade" id="newsUploadModal" tabindex="-1" aria-labelledby="newsUploadModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newsUploadModalLabel">Neuen News-Beitrag erstellen</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Schließen"></button>
                </div>
                <div class="modal-body">
                    <form id="submitNewsForm" action="/news/submit" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="title" class="form-label">Titel</label>
                            <input type="text" id="title" name="title" placeholder="Titel" class="form-control"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Inhalt</label>
                            <textarea id="content" name="content" rows="10" placeholder="Inhalt" class="form-control"
                                required></textarea>
                        </div>

                        <div id="dropzone">
                            <p class="dropper">Bild hierhin ziehen oder mit dem Button laden</p>
                            <input type="file" id="fileElem" name="imageFile" accept="image/*"
                                onchange="handleFiles(this.files)">
                        </div>

                        <div class="d-flex justify-content-center align-items-center" style="height: 300px;">
                            <img id="preview" class="img-fluid" alt="Bildvorschau">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-light" form="submitNewsForm">Beitrag veröffentlichen</button>
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Abbrechen</button>

                </div>
            </div>
        </div>
    </div>


    <!-- edit news modal -->
    <div class="modal fade" id="editNewsModal" tabindex="-1" aria-labelledby="editNewsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">News-Beitrag bearbeiten</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Schließen"></button>
                </div>
                <div class="modal-body">
                    <form id="editNewsForm" action="/admin/news/edit" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="news_id" id="editNewsId">
                        <div class="mb-3">
                            <label for="editTitle" class="form-label">Titel</label>
                            <input type="text" id="editTitle" name="title" placeholder="Titel" class="form-control"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="editContent" class="form-label">Inhalt</label>
                            <textarea id="editContent" name="content" rows="10" placeholder="Inhalt"
                                class="form-control" required></textarea>
                        </div>

                        <div id="editDropzone">
                            <p class="dropper">Bild hierhin ziehen oder mit dem Button laden</p>
                            <input type="file" id="editFileElem" name="imageFile" accept="image/*"
                                onchange="handleEditFiles(this.files)">
                        </div>
                        <div class="d-flex justify-content-center align-items-center" style="height: 300px;">
                            <img id="editPreview" class="img-fluid" alt="Bildvorschau">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-light" form="editNewsForm">Änderungen speichern</button>
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Abbrechen</button>
                    <form id="deleteNewsForm" action="/news/delete" method="post">
                        <button type="button" class="btn btn-danger" id="deleteButton" data-bs-toggle="modal"
                            data-bs-target="#deleteNewsModal">
                            <i class="fas fa-trash-alt"></i> Löschen
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- delete news modal -->
    <div class="modal fade" id="deleteNewsModal" tabindex="-1" aria-labelledby="deleteNewsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteNewsForm" action="/admin/news/delete" method="post">
                    <input type="hidden" name="news_id" id="deleteNewsId">
                    <div class="modal-header">
                        <h5 class="modal-title">News-Beitrag löschen</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Schließen"></button>
                    </div>
                    <div class="modal-body">
                        <p>Bist du sicher, dass du diesen News-Beitrag löschen möchtest?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Abbrechen</button>
                        <button type="submit" class="btn btn-danger">Löschen</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src='/public/js/dropzone.js'></script>
    <script src='/public/js/newsModal.js'></script>

    <?php include 'src/views/includes/footer.php'; ?>
</body>