<?php include 'src/views/includes/header.php'; ?>

<style>
    #dropzone,
    #editDropzone {
        border: 2px dashed #007bff;
        background-color: #f8f9fa;
        padding: 30px;
        text-align: center;
        border-radius: 8px;
        width: 100%;
        margin-bottom: 20px;
        position: relative;
    }

    #fileElem,
    #editFileElem {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    #preview,
    #editPreview {
        display: none;
        max-width: 100%;
        max-height: 300px;
        margin-top: 20px;
        border: 1px solid #ddd;
        padding: 5px;
        border-radius: 4px;
    }

    .news-row:hover {
        background-color: #f1f1f1;
        cursor: pointer;
    }
</style>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Newsverwaltung</h1>

        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="alert alert-info alert-dismissible fade show" id="flashMessage">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Schließen"></button>
                <?= $_SESSION['flash_message'];
                unset($_SESSION['flash_message']); ?>
            </div>
            <script src='/public/js/flashMessage.js'></script>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle table-hover">
                <thead class="table-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Titel</th>
                        <th scope="col">Bild</th>
                        <th scope="col">Inhalt</th>
                        <th scope="col">Erstellt am</th>
                        <th scope="col">Erstellt von</th>
                    </tr>
                </thead>
                <tbody id="newsTableBody">
                    <?php foreach ($news as $room): ?>
                        <tr class="news-row" data-news-id="<?= $room['news_id']; ?>"
                            data-title="<?= htmlspecialchars($room['title'], ENT_QUOTES, 'UTF-8'); ?>"
                            data-image-path="<?= htmlspecialchars($room['image_path'], ENT_QUOTES, 'UTF-8'); ?>"
                            data-content="<?= htmlspecialchars($room['content'], ENT_QUOTES, 'UTF-8'); ?>"
                            data-created-at="<?= $room['created_at']; ?>" data-created-by="<?= $room['created_by']; ?>">
                            <td><?= htmlspecialchars($room['news_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?= htmlspecialchars($room['title'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="text-center">
                                <?php if (!empty($room['image_path'])): ?>
                                    <img src="/<?= htmlspecialchars($room['image_path'], ENT_QUOTES, 'UTF-8'); ?>"
                                        alt="News Bild" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                <?php else: ?>
                                    <span class="text-muted">Kein Bild</span>
                                <?php endif; ?>
                            </td>
                            <td><?= nl2br(htmlspecialchars($room['content'], ENT_QUOTES, 'UTF-8')); ?></td>
                            <td><?= date('d.m.Y H:i', strtotime($room['created_at'])); ?></td>
                            <td><?= htmlspecialchars(User::getUsernameByID($room['created_by']), ENT_QUOTES, 'UTF-8'); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="6" class="text-center">
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#newsUploadModal">
                                <i class="fas fa-plus"></i> Neue News hinzufügen
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- upload news modal -->
    <div class="modal fade" id="newsUploadModal" tabindex="-1" aria-labelledby="newsUploadModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newsUploadModalLabel">Neuen News-Beitrag erstellen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Schließen"></button>
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

                        <img id="preview" alt="Bildvorschau">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                    <button type="submit" class="btn btn-primary" form="submitNewsForm">Beitrag veröffentlichen</button>
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Schließen"></button>
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

                        <img id="editPreview" alt="Bildvorschau">
                    </form>
                </div>
                <div class="modal-footer">
                    <form id="deleteNewsForm" action="/news/delete" method="post">
                        <button type="button" class="btn btn-danger" id="deleteButton" data-bs-toggle="modal"
                            data-bs-target="#deleteNewsModal">
                            <i class="fas fa-trash-alt"></i> Löschen
                        </button>
                    </form>
                    <button type="submit" class="btn btn-primary" form="editNewsForm">Änderungen speichern</button>
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
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Schließen"></button>
                    </div>
                    <div class="modal-body">
                        <p>Bist du sicher, dass du diesen News-Beitrag löschen möchtest?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
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