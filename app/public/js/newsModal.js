document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.news-row').forEach(row => {
        row.style.cursor = 'pointer';
        row.addEventListener('click', function () {
            const newsId = this.getAttribute('data-news-id');
            const title = this.getAttribute('data-title');
            const content = this.getAttribute('data-content');
            const imagePath = this.getAttribute('data-image-path');

            document.getElementById('editNewsId').value = newsId;
            document.getElementById('editTitle').value = title;
            document.getElementById('editContent').value = content;

            document.getElementById('deleteNewsId').value = newsId;

            if (imagePath) {
                document.getElementById('editPreview').src = '/' + imagePath;
                document.getElementById('editPreview').style.display = 'block';
            } else {
                document.getElementById('editPreview').style.display = 'none';
            }

            const editModal = new bootstrap.Modal(document.getElementById('editNewsModal'));
            editModal.show();
        });
    });

    window.handleEditFiles = function (files) {
        const preview = document.getElementById('editPreview');
        if (files.length > 0) {
            const file = files[0];
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    }

    window.handleFiles = function (files) {
        const preview = document.getElementById('preview');
        if (files.length > 0) {
            const file = files[0];
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    }

    const deleteButton = document.getElementById('deleteButton');
    if (deleteButton) {
        deleteButton.addEventListener('click', function () {
            const newsId = document.getElementById('editNewsId').value;
            document.getElementById('deleteNewsId').value = newsId;
        });
    }
});
