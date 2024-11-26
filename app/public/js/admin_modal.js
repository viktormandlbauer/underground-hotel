document.addEventListener('DOMContentLoaded', function () {
    // Bearbeiten-Modal
    var editUserModal = document.getElementById('editUserModal');
    editUserModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var userId = button.getAttribute('data-user-id');
        var pronouns = button.getAttribute('data-pronouns');
        var username = button.getAttribute('data-username');
        var givenname = button.getAttribute('data-givenname');
        var surname = button.getAttribute('data-surname');
        var email = button.getAttribute('data-email');
        var role = button.getAttribute('data-role');

        // Formularfelder füllen
        document.getElementById('editUserId').value = userId;
        document.getElementById('editPronouns').value = pronouns;
        document.getElementById('editUsername').value = username;
        document.getElementById('editGivenname').value = givenname;
        document.getElementById('editSurname').value = surname;
        document.getElementById('editEmail').value = email;
        document.getElementById('editRole').value = role;
    });

    // Löschen-Modal
    var deleteUserModal = document.getElementById('deleteUserModal');
    deleteUserModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var userId = button.getAttribute('data-user-id');
        var username = button.getAttribute('data-username');

        // Nachricht aktualisieren
        document.getElementById('deleteUserMessage').textContent = 'Sind Sie sich sicher, dass Sie den Benutzer "' + username + '" löschen möchten?';

        // Benutzer-ID setzen
        document.getElementById('deleteUserId').value = userId;
    });
});