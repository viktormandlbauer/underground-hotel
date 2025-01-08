<?php include 'src/views/includes/header.php'; ?>
<link rel="stylesheet" href="/public/css/modal.css">

<style>
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
</style>

<body>
    <?php include 'src/views/includes/navbar.php'; ?>

    <div class="container mt-5 content-wrapper">
        <div class="row bg-dark text-white py-4 rounded">
        <h1 id="Pages" class="mb-4 text-center display-3">Raumverwaltung</h1>

        <?php include 'src/views/includes/flashmessage.php'; ?>


        <div class="table-responsive">
            <table class="table table-dark table-bordered align-middle table-hover tablesorter">
                <thead>
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
                    <?php foreach ($rooms as $room): ?>
                        <tr class="room-row"
                            data-number="<?= $room['number']; ?>"
                            data-name="<?= $room['name']; ?>"
                            data-description="<?= $room['description']; ?>"
                            data-type="<?= $room['type']; ?>"
                            data-price_per_night="<?= $room['price_per_night']; ?>"
                            data-image_path="<?= $room['image_path']; ?>">

                            <td><?= $room['number']; ?></td>
                            <td><?= $room['name']; ?></td>
                            <td><?= nl2br($room['description']); ?></td>
                            <td><?= $room['type']; ?></td>
                            <td><?= $room['price_per_night']; ?> €</td>
                            <td class="text-center">
                                <?php if (!empty($room['image_path'])): ?>
                                    <img src="/<?= $room['image_path']; ?>"
                                        alt="Raumbild" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                <?php else: ?>
                                    <span class="text-muted">Kein Bild</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                
                        
                    
            </table>
            
        </div>
        <td colspan="6" class="text-center">
                            <button type="button" od = "addRow" class="add-row btn" data-bs-toggle="modal"
                                data-bs-target="#roomUploadModal">
                                <i class="fas fa-plus plus-icon"></i>
                            </button>
                        </td>
    </div>
</div>

    <!-- Create room modal -->
    <div class="modal fade" id="roomUploadModal" tabindex="-1" aria-labelledby="roomUploadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="roomUploadModalLabel">Neues Zimmer erstellen</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Schließen"></button>
                </div>
                <div class="modal-body">
                    <form id="submitRoomForm" action="/admin/rooms/create" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="roomName" class="form-label">Room Name</label>
                            <input type="text" class="form-control bg-dark text-white border-white" id="roomName" name="room_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="roomNumber" class="form-label">Room Number</label>
                            <input type="number" class="form-control bg-dark text-white border-white" id="roomNumber" name="room_number" required>
                        </div>

                        <div class="mb-3">
                            <label for="roomType" class="form-label">Room Type</label>
                            <select class="form-select bg-dark text-white border-white" id="roomType" name="room_type" required>
                                <option value="">Select a type</option>
                                <option value="single">Single</option>
                                <option value="double">Double</option>
                                <option value="suite">Suite</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="roomDescription" class="form-label">Beschreibung</label>
                            <textarea class="form-control bg-dark text-white border-white" id="roomDescription" name="room_description"
                                rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="pricePerNight" class="form-label">Preis pro Nacht</label>
                            <input type="number" class="form-control bg-dark text-white border-white" id="price_per_night" name="price_per_night"
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
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Abbrechen</button>
                    <button type="submit" class="btn btn-light" form="submitRoomForm">Zimmer anlegen</button>
                </div>
            </div>
        </div>
    </div>


    <!-- edit room modal -->
    <div class="modal fade" id="editRoomModal" tabindex="-1" aria-labelledby="editRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Zimmer bearbeiten</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Schließen"></button>
                </div>
                <div class="modal-body">
                    <form id="editRoomForm" action="/admin/rooms/edit" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="editNumber" class="form-label">Zimmernummer</label>
                            <input type="text" id="editNumber" name="number" placeholder="Zimmernummer"
                                class="form-control bg-dark text-white border-white" required>
                        </div>
                        <div class="mb-3">
                            <label for="editName" class="form-label">Bezeichnung</label>
                            <input type="text" id="editName" name="name" placeholder="Bezeichnung" 
                            class="form-control bg-dark text-white border-white" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDescription" class="form-label">Beschreibung</label>
                            <input type="text" id="editDescription" name="description" placeholder="Beschreibung"
                                class="form-control bg-dark text-white border-white" required>
                        </div>

                        <div class="mb-3">
                            <label for="editType" class="form-label">Zimmerart</label>
                            <select class="form-select bg-dark text-white border-white" id="editType" name="type" required>
                                <option value="">Select a type</option>
                                <option value="single">Single</option>
                                <option value="double">Double</option>
                                <option value="suite">Suite</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="editPricePerNight" class="form-label">Preis pro Nacht</label>
                            <input type="number" id="editPricePerNight" name="price_per_night" placeholder="Preis pro Nacht"
                                class="form-control bg-dark text-white border-white" required>
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
                    <button type="submit" class="btn btn-light" form="editRoomForm">Änderungen speichern</button>
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
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Schließen"></button>
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