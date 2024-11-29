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

<title>News Upload</title>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form id="submitNewsForm" action="/news/submit" method="post" enctype="multipart/form-data">
                <h1 class="mb-4">Neuen News-Beitrag erstellen</h1>

                <div class="mb-3">
                    <label for="title" class="form-label">Titel</label>
                    <input type="text" id="title" name="title" placeholder="Titel" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Inhalt</label>
                    <textarea id="content" name="content" rows="10" placeholder="Inhalt" class="form-control" required></textarea>
                </div>
                
                <div id="dropzone">
                    <p class="dropper">Bild hierhin ziehen oder mit dem Button laden</p>
                    <input type="file" id="fileElem" name="imageFile" multiple accept="image/*" onchange="handleFiles(this.files)">
                </div>
                
                <img id="preview" alt="Bildvorschau">

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-2">Beitrag veröffentlichen</button>
                    <button type="button" class="btn btn-danger" onclick="window.location.href='/news'">Abbrechen</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="/public/js/dropzone.js"></script>

<?php include 'src/views/includes/footer.php'; ?>

