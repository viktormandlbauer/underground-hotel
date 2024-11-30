document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        var alertElement = document.getElementById('flashMessage');
        var alert = new bootstrap.Alert(alertElement);
        alert.close();
    }, 3000);
});



