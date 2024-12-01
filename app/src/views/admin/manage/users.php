<?php include 'src/views/includes/header.php'; ?>

<script src='/public/js/admin_modal.js'></script>
<title>Benutzerverwaltung</title>

<style>
    .modal-content {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        background-color: #007bff;
        ;
        color: #fff;
    }

    .delete-header {
        background-color: #dc3545;
        color: #fff;
    }

    .modal-footer {
        justify-content: space-between;
    }
</style>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Benutzerverwaltung</h1>

        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="alert alert-info alert-dismissible fade show" id="flashMessage">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <?= $_SESSION['flash_message'];
                unset($_SESSION['flash_message']); ?>
            </div>
            <script src='/public/js/flashMessage.js'></script>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-bordered align-middle table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Anrede</th>
                        <th>Benutzername</th>
                        <th>Vorname</th>
                        <th>Nachname</th>
                        <th>E-Mail</th>
                        <th>Rolle</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
                    <?php foreach ($users as $user): ?>
                        <tr class="user-row" data-user-id="<?= $user['user_id']; ?> " style="cursor: pointer"
                            data-pronouns="<?= $user['pronouns']; ?>" data-username="<?= $user['username']; ?>"
                            data-givenname="<?= $user['givenname']; ?>" data-surname="<?= $user['surname']; ?>"
                            data-email="<?= $user['email']; ?>" data-role="<?= $user['role']; ?>">
                            <td><?= $user['user_id']; ?></td>
                            <td><?= $user['pronouns']; ?></td>
                            <td><?= $user['username']; ?></td>
                            <td><?= $user['givenname']; ?></td>
                            <td><?= $user['surname']; ?></td>
                            <td><?= $user['email']; ?></td>
                            <td><?= $user['role']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="7" class="text-center">
                            <a href="#" id="addUserRow" class="d-block py-3 text-primary"
                                style="border: 2px dashed #0d6efd; border-radius: 5px;">
                                <i class="fas fa-plus fa-2x"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="/admin/users/edit" method="POST">
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
                        <button type="button" class="btn btn-danger me-auto delete-button">
                            <i class="fas fa-trash-alt"></i> Löschen
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="/admin/users/add" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">Neuen Benutzer anlegen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Schließen"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="addPronouns" class="form-label">Anrede/Pronomen</label>
                            <select class="form-select" id="addPronouns" name="pronouns">
                                <option value="">Bitte wählen</option>
                                <option value="Herr">Herr</option>
                                <option value="Frau">Frau</option>
                                <option value="Divers">Divers</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="addGivenname" class="form-label">Vorname</label>
                            <input type="text" class="form-control" id="addGivenname" name="givenname" required />
                        </div>
                        <div class="mb-3">
                            <label for="addSurname" class="form-label">Nachname</label>
                            <input type="text" class="form-control" id="addSurname" name="surname" required />
                        </div>
                        <div class="mb-3">
                            <label for="addEmail" class="form-label">E-Mail</label>
                            <input type="email" class="form-control" id="addEmail" name="email" required />
                        </div>
                        <div class="mb-3">
                            <label for="addRole" class="form-label">Rolle</label>
                            <select class="form-select" id="addRole" name="role" required>
                                <option value="">Bitte wählen</option>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="addUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" id="addUsername" name="username" required />
                        </div>
                        <div class="mb-3">
                            <label for="addPassword" class="form-label">Passwort</label>
                            <input type="password" class="form-control" id="addPassword" name="password" required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Anlegen</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="/admin/users/delete" method="POST">
                    <div class="modal-header delete-header">
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

</body>
<?php include 'src/views/includes/footer.php'; ?>