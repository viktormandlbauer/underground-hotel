document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.room-row').forEach(row => {
        row.style.cursor = 'pointer';
        row.addEventListener('click', function () {

            const number = this.getAttribute('data-number');
            const name = this.getAttribute('data-name');
            const description = this.getAttribute('data-description');
            const type = this.getAttribute('data-type');
            const price_per_night = this.getAttribute('data-price_per_night');
            const imagePath = this.getAttribute('data-image-path');

            document.getElementById('editNumber').value = number;
            document.getElementById('editName').value = name;
            document.getElementById('editDescription').value = description;
            document.getElementById('editType').value = type;
            document.getElementById('editPricePerNight').value = price_per_night;

            if (imagePath) {
                document.getElementById('editPreview').src = '/' + imagePath;
                document.getElementById('editPreview').style.display = 'block';
            } else {
                document.getElementById('editPreview').style.display = 'none';
            }

            const editModal = new bootstrap.Modal(document.getElementById('editRoomModal'));
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
            const number = document.getElementById('editNumber').value;
            document.getElementById('deleteRoomNumber').value = number;
        });
    }
});
