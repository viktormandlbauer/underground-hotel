<?php
include 'src/views/includes/header.php';
require 'src/controllers/AdminController.php';
?>

<script src="/public/js/admin_modal.js"></script>

<title>Benutzerverwaltung</title>

<style>
    .container {
        margin-top: 50px;
    }

    .table {
        width: 100%;
        margin: 20px 0;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        padding: 15px;
        text-align: left;
        border: 1px solid #ddd;
    }

    .table th {
        background-color: #f4f4f4;
        color: #333;
    }

    .table tr:hover {
        background-color: #f1f1f1;
    }

    .btn {
        padding: 5px 10px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }

    .btn-warning {
        background-color: #ffc107;
        color: #fff;
    }

    .btn-danger {
        background-color: #dc3545;
        color: #fff;
    }

    .btn-delete {
        background: none;
        border: none;
        color: #dc3545;
        cursor: pointer;
        padding: 0;
        font-size: 18px;
        vertical-align: middle;
    }

    .modal-content {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        background-color: #dc3545;
        color: #fff;
    }

    .modal-footer {
        justify-content: space-between;
    }

    .custom-modal-header {
        background-color: #007bff;
        color: #fff;
    }
</style>

<div class="container">
    <h1 class="mb-4">Benutzerverwaltung</h1>
    <?php if (isset($_SESSION['flash_message'])): ?>
        <div class="alert alert-info">
            <?= $_SESSION['flash_message'];
            unset($_SESSION['flash_message']); ?>
        </div>
    <?php endif; ?>
    <table class="table">
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
        <tbody id="userTableBody">
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['user_id']; ?></td>
                    <td><?= $user['pronouns']; ?></td>
                    <td><?= $user['username']; ?></td>
                    <td><?= $user['givenname']; ?></td>
                    <td><?= $user['surname']; ?></td>
                    <td><?= $user['email']; ?></td>
                    <td><?= $user['role']; ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm edit-button" data-bs-toggle="modal"
                            data-bs-target="#editUserModal" data-user-id="<?= $user['user_id']; ?>"
                            data-pronouns="<?= $user['pronouns']; ?>" data-username="<?= $user['username']; ?>"
                            data-givenname="<?= $user['givenname']; ?>" data-surname="<?= $user['surname']; ?>"
                            data-email="<?= $user['email']; ?>" data-role="<?= $user['role']; ?>">
                            Bearbeiten
                        </button>
                        <button class="btn-delete delete-button" data-bs-toggle="modal" data-bs-target="#deleteUserModal"
                            data-user-id="<?= $user['user_id']; ?>" data-username="<?= $user['username']; ?>">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="/admin/users/save" method="POST">
                <div class="modal-header custom-modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Benutzer bearbeiten</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Schließen"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="editUserId" id="editUserId" value="" />
                    <div class="mb-3">
                        <label for="editPronouns" class="form-label">Anrede/Pronomen</label>
                        <select class="form-select" id="editPronouns" name="pronouns">
                            <option value="">Bitte wählen</option>
                            <option value="Herr">Herr</option>
                            <option value="Frau">Frau</option>
                            <option value="Divers">Divers</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editUsername" class="form-label">Benutzername</label>
                        <input type="text" class="form-control" id="editUsername" name="username" required />
                    </div>
                    <div class="mb-3">
                        <label for="editGivenname" class="form-label">Vorname</label>
                        <input type="text" class="form-control" id="editGivenname" name="givenname" required />
                    </div>
                    <div class="mb-3">
                        <label for="editSurname" class="form-label">Nachname</label>
                        <input type="text" class="form-control" id="editSurname" name="surname" required />
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">E-Mail</label>
                        <input type="email" class="form-control" id="editEmail" name="email" required />
                    </div>
                    <div class="mb-3">
                        <label for="editRole" class="form-label">Rolle</label>
                        <select class="form-select" id="editRole" name="role" required>
                            <option value="">Bitte wählen</option>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editPassword" class="form-label">Neues Passwort</label>
                        <input type="password" class="form-control" id="editPassword" name="password" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Speichern</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="/admin/users/delete" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel">Benutzer löschen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Schließen"></button>
                </div>
                <div class="modal-body">
                    <p id="deleteUserMessage">Sind Sie sich sicher, dass Sie den Benutzer löschen möchten?</p>
                    <input type="hidden" name="deleteUserId" id="deleteUserId" value="" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                    <button type="submit" class="btn btn-danger">Löschen</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php include 'src/views/includes/footer.php'; ?>