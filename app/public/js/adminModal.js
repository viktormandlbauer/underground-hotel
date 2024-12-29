document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.user-row').forEach(function (row) {
        row.addEventListener('click', function (e) {
            if (e.target.tagName.toLowerCase() === 'a' || e.target.tagName.toLowerCase() === 'i') {
                return;
            }

            var userId = this.getAttribute('data-user-id');
            var pronouns = this.getAttribute('data-pronouns');
            var username = this.getAttribute('data-username');
            var givenname = this.getAttribute('data-givenname');
            var surname = this.getAttribute('data-surname');
            var email = this.getAttribute('data-email');
            var role = this.getAttribute('data-role');
            var state = this.getAttribute('data-state');

            document.getElementById('editUserId').value = userId;
            document.getElementById('editPronouns').value = pronouns;
            document.getElementById('editUsername').value = username;
            document.getElementById('editGivenname').value = givenname;
            document.getElementById('editSurname').value = surname;
            document.getElementById('editEmail').value = email;
            document.getElementById('editRole').value = role;
            document.getElementById('editState').value = state;
            document.getElementById('editPassword').value = '';

            var editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
            editModal.show();
        });
    });

    document.querySelector('#editUserModal .delete-button').addEventListener('click', function () {
        var userId = document.getElementById('editUserId').value;
        var username = document.getElementById('editUsername').value; 
        document.getElementById('deleteUserMessage').textContent = 'Sind Sie sich sicher, dass Sie den Benutzer "' + username + '" löschen möchten?';
        document.getElementById('deleteUserId').value = userId;

        var deleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        deleteModal.show();
    });
});
