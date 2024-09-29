<?php
include 'src/views/includes/header.php';
include 'src/views/includes/navbar.php';
require 'src/models/user.php';
?>

<?php $users = \App\Models\User::getAllUsers() ?>

    <div class="container mt-5">
        <h1 class="mb-4">Benutzerverwaltung</h1>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Anrede</th>
                    <th>Benutzername</th>
                    <th>Vorname</th>
                    <th>Nachname</th>
                    <th>E-Mail</th>
                    <th>Rolle</th>
                    <th>Aktionen</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($user['pronouns']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['givenname']); ?></td>
                    <td><?php echo htmlspecialchars($user['surname']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                    <td>
                        <!-- Bearbeiten-Formular -->
                        <form method="post" action="/controllers/adminpage" style="display: inline;">
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>">
                            <input type="hidden" name="username" value="<?php echo htmlspecialchars($user['username']); ?>">
                            <input type="hidden" name="givenname" value="<?php echo htmlspecialchars($user['givenname']); ?>">
                            <input type="hidden" name="surname" value="<?php echo htmlspecialchars($user['surname']); ?>">
                            <input type="hidden" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                            <input type="hidden" name="pronouns" value="<?php echo htmlspecialchars($user['pronouns']); ?>">
                            <button type="submit" name="edit" data-toggle="modal" data-target="#editUserModal" class="btn btn-warning btn-sm">Bearbeiten</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="public/js/userEdit.js"></script>

<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editUserModalLabel">Benutzer bearbeiten</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Schließen"></button>
      </div>
      <div class="modal-body">
        <form id="editUserForm" action="/controllers/adminpage/save">
          <input type="hidden" id="editUserId" name="user_id">

          <div class="mb-3">
            <label for="editPronouns" class="form-label">Anrede/Pronomen</label>
            <input type="text" class="form-control" id="editPronouns" name="pronouns">
          </div>
          
          <div class="mb-3">
            <label for="editUsername" class="form-label">Benutzername</label>
            <input type="text" class="form-control" id="editUsername" name="username" required>
          </div>
          
          <div class="mb-3">
            <label for="editGivenname" class="form-label">Vorname</label>
            <input type="text" class="form-control" id="editGivenname" name="givenname" required>
          </div>
          
          <div class="mb-3">
            <label for="editSurname" class="form-label">Nachname</label>
            <input type="text" class="form-control" id="editSurname" name="surname" required>
          </div>
          
          <div class="mb-3">
            <label for="editEmail" class="form-label">E-Mail</label>
            <input type="email" class="form-control" id="editEmail" name="email" required>
          </div>
                  
          <div class="mb-3">
            <label for="editRole" class="form-label">Rolle</label>
            <input type="text" class="form-control" id="editRole" name="role" required>
          </div>

          <button type="submit" class="btn btn-primary">Speichern</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include 'src/views/includes/footer.php'; ?>