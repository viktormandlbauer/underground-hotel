<?php include 'src/views/includes/header.php'; ?>
<link rel="stylesheet" href="/public/css/modal.css">

<body>

    <?php include 'src/views/includes/navbar.php'; ?>

    <div class="container mt-5 content-wrapper">
        <div class="row bg-dark text-white py-4 rounded">
            <h1 id="Pages" class="mb-4 text-center display-3">Benutzerverwaltung</h1>

            <?php if (isset($_SESSION['flash_message'])): ?>
                <div class="alert alert-info alert-dismissible fade show" id="flashMessage">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <?= htmlspecialchars($_SESSION['flash_message'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
                <script src='/public/js/flashMessage.js'></script>
            <?php endif; ?>

            <div class="table-responsive">
                <table id="sortedTable" class="table table-dark table-bordered align-middle table-hover tablesorter">
                    <thead>
                        <tr>
                            <th data-sort="number">ID</th>
                            <th data-sort="text">Anrede</th>
                            <th data-sort="text">Benutzername</th>
                            <th data-sort="text">Vorname</th>
                            <th data-sort="text">Nachname</th>
                            <th data-sort="text">E-Mail</th>
                            <th data-sort="text">Rolle</th>
                            <th data-sort="text">Status</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                        <?php foreach ($users as $user): ?>
                            <tr class="user-row" 
                                data-user-id= "<?=$user['user_id'] ?>"
                                data-pronouns="<?= $user['pronouns'] ?>" 
                                data-username="<?= $user['username'] ?>"
                                data-givenname="<?= $user['givenname'] ?>" 
                                data-surname="<?= $user['surname'] ?>"
                                data-email="<?= $user['email'] ?>" 
                                data-role="<?= $user['role'] ?>"
                                data-state="<?= $user['user_state'] ?>">
                                <td><?= $user['user_id'] ?></td>
                                <td><?= $user['pronouns'] ?></td>
                                <td><?= $user['username'] ?></td>
                                <td><?= $user['givenname'] ?></td>
                                <td><?= $user['surname'] ?></td>
                                <td><?= $user['email'] ?></td>
                                <td><?= $user['role'] ?></td>
                                <td class="text-center">
                                    <?php if ($user['user_state'] == 'active'): ?>
                                        <span class="status-indicator bg-success"></span>
                                    <?php else: ?>
                                        <span class="status-indicator bg-danger"></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="8" class="text-center">
                                <button type="button" id="addRow" class="add-row btn" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                    <i class="fas fa-plus plus-icon"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Edit User Modal -->
        <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="/admin/users/edit" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserModalLabel">Benutzer bearbeiten</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Schließen"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="editUserId" id="editUserId" value="" />
                            <div class="mb-3">
                                <label for="editPronouns" class="form-label">Anrede/Pronomen</label>
                                <select class="form-select bg-dark text-white border-white" id="editPronouns" name="pronouns" required>
                                    <option value="">Bitte wählen</option>
                                    <option value="Herr">Herr</option>
                                    <option value="Frau">Frau</option>
                                    <option value="Divers">Divers</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editUsername" class="form-label">Benutzername</label>
                                <input type="text" class="form-control bg-dark text-white border-white" id="editUsername" name="username" required />
                            </div>
                            <div class="mb-3">
                                <label for="editGivenname" class="form-label">Vorname</label>
                                <input type="text" class="form-control bg-dark text-white border-white" id="editGivenname" name="givenname" required />
                            </div>
                            <div class="mb-3">
                                <label for="editSurname" class="form-label">Nachname</label>
                                <input type="text" class="form-control bg-dark text-white border-white" id="editSurname" name="surname" required />
                            </div>
                            <div class="mb-3">
                                <label for="editEmail" class="form-label">E-Mail</label>
                                <input type="email" class="form-control bg-dark text-white border-white" id="editEmail" name="email" required />
                            </div>
                            <div class="mb-3">
                                <label for="editRole" class="form-label">Rolle</label>
                                <select class="form-select bg-dark text-white border-white" id="editRole" name="role" required>
                                    <option value="">Bitte wählen</option>
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editState" class="form-label">Status</label>
                                <select class="form-select bg-dark text-white border-white" id="editState" name="state" required>
                                    <option value="">Bitte wählen</option>
                                    <option value="active">Aktiv</option>
                                    <option value="inactive">Inaktiv</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editPassword" class="form-label">Neues Passwort</label>
                                <input type="password" class="form-control bg-dark text-white border-white" id="editPassword" name="password" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-light">Speichern</button>
                            <button type="button" class="btn btn-danger me-auto delete-button">
                                <i class="fas fa-trash-alt"></i> Löschen
                            </button>
                            <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Abbrechen</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add User Modal -->
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
                                <select class="form-select bg-dark text-white border-white" id="addPronouns" name="pronouns" required>
                                    <option value="">Bitte wählen</option>
                                    <option value="Herr">Herr</option>
                                    <option value="Frau">Frau</option>
                                    <option value="Divers">Divers</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="addGivenname" class="form-label">Vorname</label>
                                <input type="text" class="form-control bg-dark text-white border-white" id="addGivenname" name="givenname" required />
                            </div>
                            <div class="mb-3">
                                <label for="addSurname" class="form-label">Nachname</label>
                                <input type="text" class="form-control bg-dark text-white border-white" id="addSurname" name="surname" required />
                            </div>
                            <div class="mb-3">
                                <label for="addEmail" class="form-label">E-Mail</label>
                                <input type="email" class="form-control bg-dark text-white border-white" id="addEmail" name="email" required />
                            </div>
                            <div class="mb-3">
                                <label for="addRole" class="form-label">Rolle</label>
                                <select class="form-select bg-dark text-white border-white" id="addRole" name="role" required>
                                    <option value="">Bitte wählen</option>
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="addState" class="form-label">Status</label>
                                <select class="form-select bg-dark text-white border-white" id="addState" name="state" required>
                                    <option value="">Bitte wählen</option>
                                    <option value="active">Aktiv</option>
                                    <option value="inactive">Inaktiv</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="addUsername" class="form-label">Username</label>
                                <input type="text" class="form-control bg-dark text-white border-white" id="addUsername" name="username" required />
                            </div>
                            <div class="mb-3">
                                <label for="addPassword" class="form-label">Passwort</label>
                                <input type="password" class="form-control bg-dark text-white border-white" id="addPassword" name="password" required />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-light">Anlegen</button>
                            <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Abbrechen</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Confirm Delete Modal -->
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
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
                            <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Abbrechen</button>
                            <button type="submit" class="btn btn-danger">Löschen</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" src="/public/js/adminModal.js"></script>
<?php include 'src/views/includes/footer.php'; ?>
