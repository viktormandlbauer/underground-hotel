<?php include 'src/views/includes/header.php'; ?>

<style>
    #dropzone {
        border: 2px dashed #007bff;
        background-color: #f8f9fa;
        padding: 30px;
        text-align: center;
        border-radius: 8px;
        width: 100%;
        margin-bottom: 20px;
        position: relative;
    }

    #fileElem {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        /* Unsichtbar */
        cursor: pointer;
    }

    #preview {
        display: none;
        max-width: 100%;
        margin-top: 20px;
        border: 1px solid #ddd;
        padding: 5px;
        border-radius: 4px;
    }
</style>

<div class="container mt-5">
    <h2>Create a New Room</h2>
    <form action="/rooms/create" method="POST" enctype="multipart/form-data">
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
            <textarea class="form-control" id="roomDescription" name="room_description" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label for="pricePerNight" class="form-label">Preis pro Nacht</label>
            <input type="number" class="form-control" id="price_per_night" name="price_per_night" step="0.01" required>
        </div>

        <div id="dropzone">
            <p class="dropper">Bild hierhin ziehen oder mit dem Button laden</p>
            <input type="file" id="fileElem" name="imageFile" multiple accept="image/*"
                onchange="handleFiles(this.files)">
        </div>

        <img id="preview" alt="Bildvorschau">

        <button type="submit" class="btn btn-primary">Create Room</button>
    </form>
</div>

<script src="/public/js/dropzone.js"></script>

<?php include 'src/views/includes/footer.php'; ?>