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
  .then(response => {
      // Überprüfen, ob die Antwort JSON ist
      const contentType = response.headers.get("content-type");
      if (contentType && contentType.includes("application/json")) {
          return response.json(); // Nur JSON parsen, wenn es auch wirklich JSON ist
      } else {
          throw new Error("Antwort ist kein gültiges JSON");
      }
  })
  .then(data => {
      if (data.success) {
          alert('Benutzerdaten erfolgreich aktualisiert.');
          location.reload(); // Seite aktualisieren, um die neuen Daten anzuzeigen
      } else {
          alert('Fehler beim Aktualisieren der Benutzerdaten.');
      }
  })
  .catch(error => {
      console.error('Fehler bei der Verarbeitung:', error);
      alert("Es ist ein Fehler aufgetreten: " + error.message);
  });
});
});
  