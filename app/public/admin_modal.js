document.addEventListener('DOMContentLoaded', function () {

  document.querySelectorAll('.btn-warning').forEach(function (editButton) {
    editButton.addEventListener('click', function (event) {
      event.preventDefault();

      const row = editButton.closest('tr');
      const userId = row.querySelector('input[name="user_id"]').value;
      const pronouns = row.cells[1].textContent.trim();
      const username = row.cells[2].textContent.trim();
      const givenname = row.cells[3].textContent.trim();
      const surname = row.cells[4].textContent.trim();
      const email = row.cells[5].textContent.trim();
      const role = row.cells[6].textContent.trim();

      document.getElementById('editUserId').value = userId;
      document.getElementById('editUsername').value = username;
      document.getElementById('editGivenname').value = givenname;
      document.getElementById('editSurname').value = surname;
      document.getElementById('editEmail').value = email;
      document.getElementById('editPronouns').value = pronouns;
      document.getElementById('editRole').value = role;

      const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
      editModal.show();
    });
  });

  document.getElementById('editUserForm').addEventListener('submit', function (event) {
    event.preventDefault();

    const formData = new FormData(this);
    console.log(formData);

    fetch('/controllers/adminpage/save', {
      method: 'POST',
      body: formData
    })
      .then(response => response.text())
      .then(text => {
        let data;
        try {
          console.log(text);
          data = JSON.parse(text);
        } catch (error) {
          console.error('Error parsing JSON:', error);
          alert('Fehler beim Verarbeiten der Serverantwort.');
          return;
        }

        if (data.success) {
          alert('Benutzerdaten erfolgreich aktualisiert.');
          location.reload();
        } else {
          alert('Fehler beim Aktualisieren der Benutzerdaten.');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Fehler beim Senden der Anfrage.');
      });
  });
});
