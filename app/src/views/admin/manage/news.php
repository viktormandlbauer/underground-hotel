<?php include 'src/views/includes/header.php';?>

<style>
.container {
    display: flex;
    justify-content: center;
    align-items: center;
}

.upload-form {
    width: 100%;
    max-width: 600px;
}

.form-floating {
    width: 100%;
    margin-bottom: 1rem;
}

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
    opacity: 0;  /* Unsichtbar */
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

.button-submit {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    margin-right: 10px;
    transition: background-color 0.3s ease;
}

.button-submit:hover {
    background-color: #0056b3;
}

.button-cancel {
    background-color: #dc3545;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    transition: background-color 0.3s ease;
}

.button-cancel:hover {
    background-color: #c82333;
}

.button-group {
    display: flex;
    justify-content: flex-end;
    width: 100%;
}
</style>

<title>News Upload</title>

<div class="container">
    <form class="upload-form" action="/news/publish" method="post" enctype="multipart/form-data">
        <h1>Neuen News-Beitrag erstellen</h1>

        <div class="form-floating">
            <input type="text" id="title" name="title" placeholder="Titel" class="form-control" required>
            <label for="title">Titel</label>
        </div>

        <div class="form-floating">
            <textarea id="content" name="content" rows="10" placeholder="Inhalt" class="form-control" required></textarea>
            <label for="content">Inhalt</label>
        </div>
        <div id="dropzone">
            <p class="dropper">Bild hierhin ziehen oder mit dem Button laden</p>
            <input type="file" id="fileElem" name="image" multiple accept="image/*" onchange="handleFiles(this.files)">
        </div>

        <img id="preview" alt="Bildvorschau">

        <div class="button-group">
            <button type="submit" class="button-submit">Beitrag veröffentlichen</button>
            <button type="button" class="button-cancel" onclick="window.location.href='/news'">Abbrechen</button>
        </div>
    </form>
</div>

<script src="/public/js/dropzone.js"></script>

<?php include 'src/views/includes/footer.php'; ?>

