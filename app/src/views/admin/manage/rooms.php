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

    .room-row:hover {
        background-color: #f1f1f1;
        cursor: pointer;
    }
</style>

<body>


    <div class="container mt-5">
        <h1 class="mb-4">Raumverwaltung</h1>

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
                        <th scope="col">Nummer</th>
                        <th scope="col">Name</th>
                        <th scope="col">Beschreibung</th>
                        <th scope="col">Typ</th>
                        <th scope="col">Preis pro Nacht</th>
                        <th scope="col">Bild</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rooms as $article): ?>
                        <tr class="room-row" data-number="<?= $article['number']; ?>"
                            data-name="<?= htmlspecialchars($article['name'], ENT_QUOTES, 'UTF-8'); ?>"
                            data-description="<?= htmlspecialchars($article['description'], ENT_QUOTES, 'UTF-8'); ?>"
                            data-type="<?= htmlspecialchars($article['type'], ENT_QUOTES, 'UTF-8'); ?>"
                            data-price_per_night="<?= $article['price_per_night']; ?>"
                            data-image_path="<?= $article['image_path']; ?>">

                            <td><?= htmlspecialchars($article['number'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?= htmlspecialchars($article['name'], ENT_QUOTES, 'UTF-8'); ?></td>

                            <td><?= nl2br(htmlspecialchars($article['description'], ENT_QUOTES, 'UTF-8')); ?></td>
                            <td><?= htmlspecialchars($article['type'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?= htmlspecialchars($article['price_per_night']); ?> €</td>
                            <td class="text-center">
                                <?php if (!empty($article['image_path'])): ?>
                                    <img src="/<?= htmlspecialchars($article['image_path'], ENT_QUOTES, 'UTF-8'); ?>"
                                        alt="Raumbild" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                <?php else: ?>
                                    <span class="text-muted">Kein Bild</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="6" class="text-center">
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#roomUploadModal">
                                <i class="fas fa-plus"></i> Neues Zimmer anlegen
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create room modal -->
    <div class="modal fade" id="roomUploadModal" tabindex="-1" aria-labelledby="roomUploadModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="roomUploadModalLabel">Neues Zimmer erstellen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Schließen"></button>
                </div>
                <div class="modal-body">
                    <form id="submitRoomForm" action="/admin/rooms/create" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="roomName" class="form-label">Room Name</label>
                            <input type="text" class="form-control" id="roomName" name="room_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="roomNumber" class="form-label">Room Number</label>
                            <input type="number" class="form-control" id="roomNumber" name="room_number" required>
                        </div>

                        <div class="mb-3">
                            <label for="roomType" class="form-label">Room Type</label>
                            <select class="form-control" id="roomType" name="room_type" required>
                                <option value="">Select a type</option>
                                <option value="single">Single</option>
                                <option value="double">Double</option>
                                <option value="suite">Suite</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="roomDescription" class="form-label">Beschreibung</label>
                            <textarea class="form-control" id="roomDescription" name="room_description"
                                rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="pricePerNight" class="form-label">Preis pro Nacht</label>
                            <input type="number" class="form-control" id="price_per_night" name="price_per_night"
                                step="0.01" required>
                        </div>

                        <div id="dropzone">
                            <p class="dropper">Bild hierhin ziehen oder mit dem Button laden</p>
                            <input type="file" id="fileElem" name="imageFile" multiple accept="image/*"
                                onchange="handleFiles(this.files)">
                        </div>

                        <img id="preview" alt="Bildvorschau">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                    <button type="submit" class="btn btn-primary" form="submitRoomForm">Zimmer anlegen</button>
                </div>
            </div>
        </div>
    </div>


    <!-- edit room modal -->
    <div class="modal fade" id="editRoomModal" tabindex="-1" aria-labelledby="editRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Zimmer bearbeiten</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Schließen"></button>
                </div>
                <div class="modal-body">
                    <form id="editRoomForm" action="/admin/rooms/edit" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="editNumber" class="form-label">Zimmernummer</label>
                            <input type="text" id="editNumber" name="number" placeholder="Zimmernummer"
                                class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="editName" class="form-label">Bezeichnung</label>
                            <input type="text" id="editName" name="name" placeholder="Bezeichnung" class="form-control"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="editDescription" class="form-label">Beschreibung</label>
                            <input type="text" id="editDescription" name="description" placeholder="Beschreibung"
                                class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="editType" class="form-label">Zimmerart</label>
                            <select class="form-control" id="editType" name="type" required>
                                <option value="">Select a type</option>
                                <option value="single">Single</option>
                                <option value="double">Double</option>
                                <option value="suite">Suite</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="editPricePerNight" class="form-label">Preis pro Nacht</label>
                            <input type="number" id="editPricePerNight" name="price_per_night" placeholder="Preis pro Nacht"
                                class="form-control" required>
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
                    <form id="deleteroomForm" action="/admin/rooms/delete" method="post">
                        <button type="button" class="btn btn-danger" id="deleteButton" data-bs-toggle="modal"
                            data-bs-target="#deleteroomModal">
                            <i class="fas fa-trash-alt"></i> Löschen
                        </button>
                    </form>
                    <button type="submit" class="btn btn-primary" form="editRoomForm">Änderungen speichern</button>
                </div>
            </div>
        </div>
    </div>


    <!-- delete room modal -->
    <div class="modal fade" id="deleteroomModal" tabindex="-1" aria-labelledby="deleteroomModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteroomForm" action="/admin/rooms/delete" method="post">
                    <input type="hidden" name="number" id="deleteRoomNumber">
                    <div class="modal-header">
                        <h5 class="modal-title">Raum löschen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Schließen"></button>
                    </div>
                    <div class="modal-body">
                        <p>Bist du sicher, dass du diesen room-Beitrag löschen möchtest?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                        <button type="submit" class="btn btn-danger">Löschen</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script src='/public/js/dropzone.js'></script>
<script src='/public/js/roomModal.js'></script>

<?php include 'src/views/includes/footer.php'; ?>