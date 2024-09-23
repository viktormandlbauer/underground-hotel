document.addEventListener('DOMContentLoaded', function () {
    // Alle Bearbeiten-Buttons abfangen
    document.querySelectorAll('.btn-warning').forEach(function (editButton) {
      editButton.addEventListener('click', function (event) {
        event.preventDefault();
        
        // User-Daten aus den Attributen holen
        const row = editButton.closest('tr');
        const userId = row.querySelector('input[name="user_id"]').value;
        const pronouns = row.cells[1].textContent.trim();
        const username = row.cells[2].textContent.trim();
        const givenname = row.cells[3].textContent.trim();
        const surname = row.cells[4].textContent.trim();
        const email = row.cells[5].textContent.trim();
        const role = row.cells[6].textContent.trim();
        
        // Modal-Felder mit Werten füllen
        document.getElementById('editUserId').value = userId;
        document.getElementById('editUsername').value = username;
        document.getElementById('editGivenname').value = givenname;
        document.getElementById('editSurname').value = surname;
        document.getElementById('editEmail').value = email;
        document.getElementById('editPronouns').value = pronouns;
        document.getElementById('editRole').value = role;

        // Modal öffnen
       const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
       editModal.show();
      });
    });
  
    // Formular-Absenden
    document.getElementById('editUserForm').addEventListener('submit', function (event) {
      event.preventDefault();
  
      // Formulardaten erfassen
      const formData = new FormData(this);
      console.log(formData);
       // AJAX-Request zum Server senden
       fetch('/controllers/adminpage/save', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())  // Hole die Antwort als Text
    .then(text => {
        const data = JSON.parse(text);   // Konvertiere den Text in JSON-Objekt
        if (data.success) {
            alert('Benutzerdaten erfolgreich aktualisiert.');
            location.reload();
        } else {
            alert('Fehler beim Aktualisieren der Benutzerdaten.');
        }
    })
    .catch(error => console.error('Error:', error));
  });
});
  